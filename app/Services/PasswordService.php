<?php

namespace App\Services;

use App\RepositoryInterfaces\PasswordRepositoryInterface;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class PasswordService
{
    public function __construct(
        public PasswordRepositoryInterface $repository,
        public MailService $mailService,
    ) {
    }

    public function check(string $md5Email): bool
    {
        return $this->repository->check($md5Email);
    }

    public function get(string $md5Email): object|null
    {
        return $this->repository->get($md5Email);
    }

    public function delete(string $email): void
    {
        $this->repository->deleteRow($email);
    }

    /**
     * @throws PHPMailerException
     */
    public function restore(array $data): array
    {
        if ($this->repository->check($data['md5Email'])) {
            return [
                'message' => __('messages.instructions_already_sent'),
            ];
        }

        $this->repository->insertRow($data['email'], $data['md5Email']);

        $message = view('emails.password-restore', [
            'md5Email' => $data['md5Email'],
        ])->render();

        $this->mailService->send([$data['email']], $message, __('messages.restore_password'));

        return [
            'message' => __('messages.instructions_sent'),
        ];
    }
}
