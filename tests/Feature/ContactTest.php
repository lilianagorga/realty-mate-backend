<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->user = $this->authUser();
    }

    #[Test]
    public function a_user_can_send_a_contact_email()
    {

        Mail::fake();

        $contactData = [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'message' => 'This is a test message.',
            'gdpr' => true,
        ];

        $response = $this->postJson('/api/contact', $contactData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Message sent successfully']);

        Mail::assertSent(ContactMail::class, function ($mail) use ($contactData) {
            return $mail->hasTo('support@realtymate.com') &&
                $mail->contactData['name'] === $contactData['name'] &&
                $mail->contactData['email'] === $contactData['email'] &&
                $mail->contactData['phone'] === $contactData['phone'] &&
                $mail->contactData['message'] === $contactData['message'];
        });
    }

    #[Test]
    public function it_validates_contact_data_before_sending_email()
    {
        $response = $this->postJson('/api/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'phone' => '',
            'message' => '',
            'gdpr' => false,
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => ['The name field is required.'],
                    'email' => ['The email field must be a valid email address.'],
                    'phone' => ['The phone field is required.'],
                    'message' => ['The message field is required.'],
                    'gdpr' => ['The gdpr field must be accepted.'],
                ],
            ]);
    }
}
