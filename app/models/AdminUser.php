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
}
