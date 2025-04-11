<?php

declare(strict_types=1);

use Sqids\Sqids;

return [
    /**
     * This value is used to shuffle the alphabet for generating IDs, ensuring they
     * remain unique to your application. In most cases, this value doesn't need
     * to be changed, as the already unique app key is used by default.
     *
     * Be cautious: changing this will invalidate all previously generated IDs.
     *
     * @see https://sqids.org/faq#unique
     */
    'shuffle_seed' => env('SQIDS_SHUFFLE_SEED', env('APP_KEY')),

    /**
     * Specify the minimum length for generated IDs. All IDs will meet or exceed
     * this length, ensuring visual consistency and making it harder to infer
     * the original sequence length. Adjust this value to suit your needs.
     *
     * @see https://sqids.org/faq#minlength
     */
    'min_length' => env('SQIDS_MIN_LENGTH', 10),

    /**
     * By default, the Sqids library does not validate decoded IDs. When enabled,
     * this toggle ensures that IDs are validated after decoding to confirm
     * they are both valid and canonical.
     *
     * @see https://sqids.org/faq#valid-ids
     */
    'validate_ids' => env('SQIDS_VALIDATE_IDS', true),

    /**
     * Provide a list of words that should not appear in generated Sqids.
     * This is useful for preventing offensive or inappropriate terms
     * from being included in your application's IDs.
     *
     * @see https://sqids.org/faq#why-blocklist
     */
    'blocklist' => Sqids::DEFAULT_BLOCKLIST,

    /**
     * Define a custom alphabet for generating IDs. If left unset, the Sqids library's
     * default alphabet will be used. Unless you need shorter, longer, or specific
     * characters in your IDs, you can leave this value as is. The alphabet is
     * always shuffled using the "shuffle seed."
     *
     * @see https://sqids.org/faq#shorter-longer
     */
    'alphabet' => env('SQIDS_ALPHABET', Sqids::DEFAULT_ALPHABET),
];
