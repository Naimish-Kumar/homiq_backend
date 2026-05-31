<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, password, textarea, select
            $table->string('group'); // general, smtp, firebase
            $table->string('label');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Seed default settings
        $defaults = [
            // General
            [
                'key' => 'site_name',
                'value' => 'HomiQ',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Site Name',
                'description' => 'The brand name or title of the housing marketplace application.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_description',
                'value' => 'Premium housing and rental marketplace dashboard.',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Site Description',
                'description' => 'A brief meta description of the marketplace used for SEO and share tags.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // SMTP
            [
                'key' => 'mail_host',
                'value' => 'smtp.mailtrap.io',
                'type' => 'text',
                'group' => 'smtp',
                'label' => 'Mail Host',
                'description' => 'SMTP mail server hostname (e.g. smtp.mailtrap.io or smtp.gmail.com).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_port',
                'value' => '2525',
                'type' => 'text',
                'group' => 'smtp',
                'label' => 'Mail Port',
                'description' => 'The connection port number for your SMTP server (e.g. 587, 465, or 2525).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_encryption',
                'value' => 'tls',
                'type' => 'text',
                'group' => 'smtp',
                'label' => 'Mail Encryption',
                'description' => 'Encryption protocol to use (e.g. tls, ssl, or none).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_username',
                'value' => '',
                'type' => 'text',
                'group' => 'smtp',
                'label' => 'Mail Username',
                'description' => 'SMTP account username or authorization ID.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_password',
                'value' => '',
                'type' => 'password',
                'group' => 'smtp',
                'label' => 'Mail Password',
                'description' => 'SMTP account password corresponding to the authentication username.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_from_address',
                'value' => 'hello@homiq.com',
                'type' => 'text',
                'group' => 'smtp',
                'label' => 'From Address',
                'description' => 'Sender email address that appears on outgoing automated emails.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'mail_from_name',
                'value' => 'HomiQ System',
                'type' => 'text',
                'group' => 'smtp',
                'label' => 'From Name',
                'description' => 'Sender display name that appears on outgoing automated emails.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Firebase
            [
                'key' => 'firebase_api_key',
                'value' => '',
                'type' => 'password',
                'group' => 'firebase',
                'label' => 'Firebase API Key',
                'description' => 'The client API key for accessing Firebase services securely.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'firebase_auth_domain',
                'value' => '',
                'type' => 'text',
                'group' => 'firebase',
                'label' => 'Firebase Auth Domain',
                'description' => 'Domain used for Firebase authentication redirect flows.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'firebase_project_id',
                'value' => '',
                'type' => 'text',
                'group' => 'firebase',
                'label' => 'Firebase Project ID',
                'description' => 'The unique identifier of your project in the Firebase console.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'firebase_storage_bucket',
                'value' => '',
                'type' => 'text',
                'group' => 'firebase',
                'label' => 'Firebase Storage Bucket',
                'description' => 'Default Cloud Storage bucket URI for file and media uploads.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'firebase_messaging_sender_id',
                'value' => '',
                'type' => 'text',
                'group' => 'firebase',
                'label' => 'Firebase Messaging Sender ID',
                'description' => 'The unique ID used to authorize push notifications on client devices.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'firebase_app_id',
                'value' => '',
                'type' => 'password',
                'group' => 'firebase',
                'label' => 'Firebase App ID',
                'description' => 'The web app credentials identifier registered under your Firebase project.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('configurations')->insert($defaults);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};
