<?php
class Gallery extends Model {

    /**
     * Get a page of gallery images.
     * $offset controls where to start — used for Load More.
     */
    public function getImages(int $limit = 6, int $offset = 0): array {
        $stmt = $this->db->prepare(
            'SELECT * FROM gallery
             ORDER BY sort_order ASC, created_at DESC
             LIMIT ? OFFSET ?'
        );
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll();
    }

    /**
     * Total count — used to know when to stop showing Load More.
     */
    public function countImages(): int {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM gallery');
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    /**
     * Save a new image record.
     */
    public function addImage(array $data): bool {
        $stmt = $this->db->prepare(
            'INSERT INTO gallery (filename, caption, location, sort_order)
             VALUES (?, ?, ?, ?)'
        );
        return $stmt->execute([
            $data['filename'],
            $data['caption']    ?? null,
            $data['location']   ?? null,
            $data['sort_order'] ?? 0,
        ]);
    }

    /**
     * Delete an image record by ID.
     */
    public function deleteImage(int $id): ?string {
        // Get filename first so we can delete the file too
        $stmt = $this->db->prepare('SELECT filename FROM gallery WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if (!$row) return null;

        $this->db->prepare('DELETE FROM gallery WHERE id = ?')->execute([$id]);
        return $row->filename;
    }

    /**
     * Get a single image by ID.
     */
    public function getImageById(int $id): ?object {
        $stmt = $this->db->prepare('SELECT * FROM gallery WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
}