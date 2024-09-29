<?php

namespace Tests\Models;

use Znck\Eloquent\Relations\BelongsToThrough;
use Znck\Eloquent\Traits\HasTableAlias;

class Comment extends Model
{
    use HasTableAlias;

    public function country(): BelongsToThrough
    {
        return $this->belongsToThrough(Country::class, [User::class, Post::class])->withDefault();
    }

    public function countryWithCustomForeignKeys(): BelongsToThrough
    {
        return $this->belongsToThrough(
            Country::class,
            [[User::class, 'custom_user_id'], Post::class],
            null,
            '',
            [Post::class => 'custom_post_id']
        );
    }

    public function countryWithTrashedUser(): BelongsToThrough
    {
        return $this->country()->withTrashed(['users.deleted_at']);
    }

    public function countryWithPrefix(): BelongsToThrough
    {
        return $this->belongsToThrough(Country::class, [User::class, Post::class], null, 'custom_');
    }

    public function grandparent(): BelongsToThrough
    {
        return $this->belongsToThrough(self::class, self::class.' as alias', null, '', [self::class => 'parent_id']);
    }

    public function user(): BelongsToThrough
    {
        return $this->belongsToThrough(User::class, Post::class);
    }
}
