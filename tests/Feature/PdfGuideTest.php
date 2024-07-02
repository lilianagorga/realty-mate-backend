<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\PdfGuideMail;
use Illuminate\Foundation\Testing\WithFaker;

class PdfGuideTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->user = $this->authUser();
    }

    #[Test]
    public function a_user_can_send_pdf_guide()
    {
        Mail::fake();

        $guideData = [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'gdpr' => true,
        ];

        $response = $this->postJson('/api/send-guide', $guideData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'PDF Guide sent successfully']);

        Mail::assertSent(PdfGuideMail::class, function ($mail) use ($guideData) {
            return $mail->hasTo($guideData['email']) &&
                $mail->userName === $guideData['name'];
        });
    }

    #[Test]
    public function it_validates_guide_request_data_before_sending_email()
    {

        $response = $this->postJson('/api/send-guide', [
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
                    'gdpr' => ['The gdpr field must be accepted.'],
                ],
            ]);
    }
}
