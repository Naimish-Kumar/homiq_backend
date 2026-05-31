<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_one_id',
    'user_two_id',
    'property_id'
])]
class Chat extends Model
{
    /**
     * Get the first user in the chat.
     */
    public function userOne(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    /**
     * Get the second user in the chat.
     */
    public function userTwo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    /**
     * Get the property associated with this chat query.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    /**
     * Get the messages for this chat.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'chat_id');
    }
}
