<?php
/**
 * Contact Model
 * Handles saving and retrieving contact form submissions.
 */
class Contact extends Model {

    /**
     * Save a new contact form submission to the database.
     * Returns true on success, false on failure.
     */
    public function saveSubmission(array $data): bool {
        $stmt = $this->db->prepare(
            'INSERT INTO contacts (fullname, email, phone, subject, message)
             VALUES (?, ?, ?, ?, ?)'
        );

        return $stmt->execute([
            $data['fullname'],
            $data['email'],
            $data['phone']  ?? null,
            $data['subject'] ?? null,
            $data['message'],
        ]);
    }

    /**
     * Get all submissions — for the admin CMS panel.
     */
    public function getAllSubmissions(): array {
        $stmt = $this->db->prepare(
            'SELECT * FROM contacts ORDER BY created_at DESC'
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Mark a submission as read.
     */
    public function markAsRead(int $id): bool {
        $stmt = $this->db->prepare(
            'UPDATE contacts SET status = "read" WHERE id = ?'
        );
        return $stmt->execute([$id]);
    }
}