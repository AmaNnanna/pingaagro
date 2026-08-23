<?php
class ContactController extends Controller
{
    private $contactModel;

    public function __construct()
    {
        $this->contactModel = $this->model('Contact');
    }

    /**
     * GET /contact — Show the form
     */
    public function index()
    {
        $data = [
            'title'    => 'Contact Us | ' . SITENAME,
            'metaDesc' => 'Get in touch with Pinga Agro Investment Limited.',
            'success'  => false,
            'errors'   => [],
            'old'      => [],  // Repopulate form fields after failed validation
        ];
        $this->view('pages/contact', $data);
    }

    /**
     * POST /contact/submit — Process the form
     */
    public function submit()
    {

        // Only allow POST requests
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URLROOT . '/contact');
            exit;
        }

        // ── Sanitise inputs ────────────────────────────────
        $old = [
            'fullname' => trim($_POST['fullname'] ?? ''),
            'email'    => trim($_POST['email']    ?? ''),
            'phone'    => trim($_POST['phone']    ?? ''),
            'subject'  => trim($_POST['subject']  ?? ''),
            'message'  => trim($_POST['message']  ?? ''),
        ];

        // ── Validate ───────────────────────────────────────
        $errors = [];

        if (empty($old['fullname'])) {
            $errors['fullname'] = 'Your full name is required.';
        }

        if (empty($old['email'])) {
            $errors['email'] = 'Your email address is required.';
        } elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address.';
        }

        if (empty($old['subject'])) {
            $errors['subject'] = 'Please tell us how you are reaching out.';
        }

        if (empty($old['message'])) {
            $errors['message'] = 'Please enter a message.';
        } elseif (strlen($old['message']) < 20) {
            $errors['message'] = 'Your message is too short — please give us a bit more detail.';
        }

        // ── If errors — go back to form with errors and old values
        if (!empty($errors)) {
            $data = [
                'title'   => 'Contact Us | ' . SITENAME,
                'success' => false,
                'errors'  => $errors,
                'old'     => $old,
            ];
            $this->view('pages/contact', $data);
            return;
        }

        // ── Save to database ───────────────────────────────────────
        $saved = $this->contactModel->saveSubmission($old);

        if ($saved) {
            // ── Send email notification to admin ───────────────────
            $this->sendAdminNotification($old);

            $data = [
                'title'   => 'Message Sent | ' . SITENAME,
                'success' => true,
                'errors'  => [],
                'old'     => [],
            ];
        } else {
            $data = [
                'title'   => 'Contact Us | ' . SITENAME,
                'success' => false,
                'errors'  => ['general' => 'Something went wrong. Please try again or email us directly.'],
                'old'     => $old,
            ];
        }

        $this->view('pages/contact', $data);
    }

    private function sendAdminNotification(array $data): void
    {
        $to      = ADMIN_EMAIL;
        $subject = 'New Enquiry: ' . ucfirst($data['subject']) . ' — ' . SITENAME;

        $message  = "A new contact form submission has been received.\n\n";
        $message .= "-------------------------------------------\n";
        $message .= "Name:    " . $data['fullname'] . "\n";
        $message .= "Email:   " . $data['email']    . "\n";
        $message .= "Phone:   " . ($data['phone'] ?: 'Not provided') . "\n";
        $message .= "Type:    " . ucfirst($data['subject']) . "\n";
        $message .= "-------------------------------------------\n\n";
        $message .= "Message:\n" . $data['message'] . "\n\n";
        $message .= "-------------------------------------------\n";
        $message .= "Reply directly to: " . $data['email'] . "\n";
        $message .= "View in admin: " . URLROOT . "/admin/contacts\n";

        $headers  = "From: " . FROM_NAME . " <" . FROM_EMAIL . ">\r\n";
        $headers .= "Reply-To: " . $data['fullname'] . " <" . $data['email'] . ">\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        // mail() works on live server automatically via cPanel
        // On local Laragon it will silently fail — that's expected
        @mail($to, $subject, $message, $headers);
    }
}
