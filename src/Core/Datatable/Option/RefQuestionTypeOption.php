<?php
/**
 * Created by PhpStorm.
 * User: Haykel.Brinis
 * Date: 22/10/2021
 * Time: 11:09
 */

namespace App\Core\Datatable\Option;


class RefQuestionTypeOption implements BuildOption
{

    const TYPE = "QuestionType";
    public function render($data): string
    {
       return "";
    }

    public function support(string $type): bool
    {
        return  $type == self::TYPE;
    }
}