<?php
class Review extends Model
{

    public function getApprovedReviews(): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM reviews WHERE status = "approved"
             ORDER BY created_at DESC'
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPendingReviews(): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM reviews WHERE status = "pending"
             ORDER BY created_at DESC'
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllReviews(): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM reviews ORDER BY created_at DESC'
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function submitReview(array $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO reviews (name, designation, review, image)
             VALUES (?, ?, ?, ?)'
        );
        return $stmt->execute([
            $data['name'],
            $data['designation'] ?? null,
            $data['review'],
            $data['image']       ?? null,
        ]);
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE reviews SET status = ? WHERE id = ?'
        );
        return $stmt->execute([$status, $id]);
    }

    public function deleteReview(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM reviews WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function countPending(): int
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) FROM reviews WHERE status = "pending"'
        );
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function getRandomApprovedReviews(int $limit = 6): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM reviews WHERE status = "approved"
         ORDER BY RAND() LIMIT ' . (int)$limit
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
