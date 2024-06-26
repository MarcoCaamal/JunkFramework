<?php

namespace Junk\Validation\Rules;

use Junk\Validation\Contracts\ValidationRuleContract;

class Email implements ValidationRuleContract
{
    /**
     *
     * @param string $field
     * @param array $data
     * @return bool
     */
    public function isValid(string $field, array $data): bool
    {
        //Because this rule not verify if the value is required
        if(empty($data[$field]) || $data[$field] === null) {
            return true;
        }
        $email = strtolower(trim($data[$field]));

        $split = explode('@', $email);

        if (count($split) != 2) {
            return false;
        }

        [$username, $domain] = $split;

        $split = explode('.', $domain);

        if (count($split) != 2) {
            return false;
        }

        [$label, $topLevelDomain] = $split;

        return strlen($username) >= 1
            && strlen($label) >= 1
            && strlen($topLevelDomain) >= 1;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return 'Email has invalid format';
    }
}
