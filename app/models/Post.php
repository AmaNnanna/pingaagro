<?php
/**
 * Post Model
 * Handles all database operations for blog posts.
 * Includes both public (frontend) and admin (CMS) methods.
 */
class Post extends Model {

    // ── PUBLIC (FRONTEND) METHODS ──────────────────────────

    public function getPublishedPosts(int $limit = 0): array {
        $sql = 'SELECT p.*, c.name AS category_name, c.slug AS category_slug
                FROM posts p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.status = "published"
                ORDER BY p.created_at DESC';
        if ($limit > 0) $sql .= ' LIMIT ' . (int)$limit;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPostBySlug(string $slug): ?object {
        $stmt = $this->db->prepare(
            'SELECT p.*, c.name AS category_name, c.slug AS category_slug
             FROM posts p
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE p.slug = ? AND p.status = "published"
             LIMIT 1'
        );
        $stmt->execute([$slug]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function getPostsByCategory(string $categorySlug): array {
        $stmt = $this->db->prepare(
            'SELECT p.*, c.name AS category_name, c.slug AS category_slug
             FROM posts p
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE c.slug = ? AND p.status = "published"
             ORDER BY p.created_at DESC'
        );
        $stmt->execute([$categorySlug]);
        return $stmt->fetchAll();
    }

    public function getCategories(): array {
        $stmt = $this->db->prepare('SELECT * FROM categories ORDER BY name ASC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countPublishedPosts(): int {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM posts WHERE status = "published"');
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    // ── ADMIN (CMS) METHODS ────────────────────────────────

    /**
     * Get ALL posts (including drafts) for the admin panel.
     */
    public function adminGetAllPosts(): array {
        $stmt = $this->db->prepare(
            'SELECT p.*, c.name AS category_name
             FROM posts p
             LEFT JOIN categories c ON p.category_id = c.id
             ORDER BY p.created_at DESC'
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Get a single post by ID — for the edit form.
     */
    public function adminGetPostById(int $id): ?object {
        $stmt = $this->db->prepare('SELECT * FROM posts WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Create a new post.
     */
    public function adminCreatePost(array $data): bool {
        $stmt = $this->db->prepare(
            'INSERT INTO posts
                (title, slug, excerpt, body, category_id, featured_image, author, status)
             VALUES
                (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        return $stmt->execute([
            $data['title'],
            $data['slug'],
            $data['excerpt']        ?? null,
            $data['body'],
            $data['category_id']    ?? null,
            $data['featured_image'] ?? null,
            $data['author']         ?? 'Pinga Agro Team',
            $data['status'],
        ]);
    }

    /**
     * Update an existing post.
     */
    public function adminUpdatePost(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            'UPDATE posts SET
                title          = ?,
                slug           = ?,
                excerpt        = ?,
                body           = ?,
                category_id    = ?,
                featured_image = ?,
                author         = ?,
                status         = ?,
                updated_at     = NOW()
             WHERE id = ?'
        );
        return $stmt->execute([
            $data['title'],
            $data['slug'],
            $data['excerpt']        ?? null,
            $data['body'],
            $data['category_id']    ?? null,
            $data['featured_image'] ?? null,
            $data['author']         ?? 'Pinga Agro Team',
            $data['status'],
            $id,
        ]);
    }

    /**
     * Delete a post by ID.
     */
    public function adminDeletePost(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM posts WHERE id = ?');
        return $stmt->execute([$id]);
    }

    /**
     * Check if a slug already exists (to prevent duplicates).
     * Optionally exclude a post ID — used when editing.
     */
    public function slugExists(string $slug, int $excludeId = 0): bool {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) FROM posts WHERE slug = ? AND id != ?'
        );
        $stmt->execute([$slug, $excludeId]);
        return (int)$stmt->fetchColumn() > 0;
    }
}