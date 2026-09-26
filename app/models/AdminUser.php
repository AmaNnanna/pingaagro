<?php

/**
 * AdminUser Model
 * Handles admin authentication and user lookup.
 */
class AdminUser extends Model
{

    /**
     * Find an admin user by email.
     * Used during login to verify credentials.
     */
    public function findByEmail(string $email): ?object
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM admin_users WHERE email = ? LIMIT 1'
        );
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Record a failed login attempt for this account, and lock it if
     * the attempt count has now reached the limit. Tied to the account
     * (not the visitor's session), so clearing cookies or using a new
     * browser tab does not reset it.
     */
    public function registerFailedLogin(int $id, int $maxAttempts, int $lockoutSeconds): void
    {
        $stmt = $this->db->prepare(
            'UPDATE admin_users SET failed_attempts = failed_attempts + 1 WHERE id = ?'
        );
        $stmt->execute([$id]);

        $stmt = $this->db->prepare('SELECT failed_attempts FROM admin_users WHERE id = ?');
        $stmt->execute([$id]);
        $attempts = (int) $stmt->fetchColumn();

        if ($attempts >= $maxAttempts) {
            $lockUntil = date('Y-m-d H:i:s', time() + $lockoutSeconds);
            $stmt = $this->db->prepare('UPDATE admin_users SET locked_until = ? WHERE id = ?');
            $stmt->execute([$lockUntil, $id]);
        }
    }

    /**
     * Clear failed-attempt count and any lockout — called on a
     * successful login.
     */
    public function resetLoginAttempts(int $id): void
    {
        $stmt = $this->db->prepare(
            'UPDATE admin_users SET failed_attempts = 0, locked_until = NULL WHERE id = ?'
        );
        $stmt->execute([$id]);
    }

    /**
     * Get dashboard stats in a single efficient query set.
     */
    public function getDashboardStats(): array
    {
        $stats = [];

        $stmt = $this->db->prepare('SELECT COUNT(*) FROM posts WHERE status = "published"');
        $stmt->execute();
        $stats['published'] = $stmt->fetchColumn();

        $stmt = $this->db->prepare('SELECT COUNT(*) FROM posts WHERE status = "draft"');
        $stmt->execute();
        $stats['drafts'] = $stmt->fetchColumn();

        $stmt = $this->db->prepare('SELECT COUNT(*) FROM contacts');
        $stmt->execute();
        $stats['contacts_total'] = $stmt->fetchColumn();

        $stmt = $this->db->prepare('SELECT COUNT(*) FROM contacts WHERE status = "unread"');
        $stmt->execute();
        $stats['contacts_unread'] = $stmt->fetchColumn();

        $stmt = $this->db->prepare('SELECT COUNT(*) FROM reviews WHERE status = "pending"');
        $stmt->execute();
        $stats['reviews_pending'] = $stmt->fetchColumn();

        return $stats;
    }

    /**
     * Get the 5 most recent posts for the dashboard.
     */
    public function getRecentPosts(): array
    {
        $stmt = $this->db->prepare(
            'SELECT id, title, status, created_at FROM posts ORDER BY created_at DESC LIMIT 5'
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Get the 5 most recent contact submissions for the dashboard.
     */
    public function getRecentContacts(): array
    {
        $stmt = $this->db->prepare(
            'SELECT id, fullname, email, subject, status, created_at
             FROM contacts ORDER BY created_at DESC LIMIT 5'
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Find an admin user by id. Used when editing/managing an admin.
     */
    public function findById(int $id): ?object
    {
        $stmt = $this->db->prepare('SELECT * FROM admin_users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Get every admin account, newest first. Used by the "Admins" page.
     */
    public function getAll(): array
    {
        $stmt = $this->db->prepare(
            'SELECT id, name, email, role, created_at FROM admin_users ORDER BY created_at DESC'
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * How many super admins currently exist.
     * Used to stop the last super admin being demoted or deleted.
     */
    public function countSuperAdmins(): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM admin_users WHERE role = 'super_admin'");
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    /**
     * Create a new admin account. Hashes the password before storing.
     */
    public function create(string $name, string $email, string $password, string $role): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO admin_users (name, email, password, role) VALUES (?, ?, ?, ?)'
        );
        return $stmt->execute([
            $name,
            $email,
            password_hash($password, PASSWORD_BCRYPT),
            $role,
        ]);
    }

    /**
     * Update an admin's own password.
     */
    public function updatePassword(int $id, string $newPassword): bool
    {
        $stmt = $this->db->prepare('UPDATE admin_users SET password = ? WHERE id = ?');
        return $stmt->execute([password_hash($newPassword, PASSWORD_BCRYPT), $id]);
    }

    /**
     * Change an admin's role (promote/demote).
     */
    public function updateRole(int $id, string $role): bool
    {
        $stmt = $this->db->prepare('UPDATE admin_users SET role = ? WHERE id = ?');
        return $stmt->execute([$role, $id]);
    }

    /**
     * Delete an admin account.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM admin_users WHERE id = ?');
        return $stmt->execute([$id]);
    }

    /**
     * Does this email already belong to an admin?
     */
    public function emailExists(string $email, int $excludeId = 0): bool
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) FROM admin_users WHERE email = ? AND id != ?'
        );
        $stmt->execute([$email, $excludeId]);
        return (int) $stmt->fetchColumn() > 0;
    }
}
