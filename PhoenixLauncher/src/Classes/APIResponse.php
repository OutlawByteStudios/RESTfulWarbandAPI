<?php
namespace PhoenixLauncher\src\Classes;

use Psr\Http\Message\ResponseInterface;

class APIResponse
{
	private $jsonResponse, $HTTPStatus;
	private function __construct()
	{
	}
	public static function create(array $response, int $HTTPStatus): self
	{
		$_ = new self ();
		
		$_->jsonResponse = json_encode ( $response );
		$_->HTTPStatus = $HTTPStatus;
		
		return $_;
	}
	public function status(): int
	{
		return $this->HTTPStatus;
	}
	public function json(): string
	{
		return $this->jsonResponse;
	}
	public function send(ResponseInterface &$response): void
	{
		return $response->withStatus($this->status())->write($this->json());
	}
}

