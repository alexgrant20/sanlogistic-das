<?php

namespace App\Interface;

interface ActivityStatusInterface
{
	public const STATUS_DRAFT = 'draft';
	public const STATUS_PENDING = 'pending';
	public const STATUS_APPROVED = 'approved';
	public const STATUS_PAID = 'paid';
	public const STATUS_REJECTED = 'rejected';
	public const STATUS_CANCEL = 'cancel';
}
