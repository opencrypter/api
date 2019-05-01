<?php
declare(strict_types=1);

namespace Core\Ui\JsonSchema;

use Core\Ui\Http\Exception\BadRequest;
use JsonSchema\Validator;

class JsonSchemaValidator
{
    /**
     * @param string $type
     * @param string $json
     *
     * @throws BadRequest
     */
    public function validate(string $type, string $json): void
    {
        $validator = new Validator();

        $body       = json_decode($json);
        $jsonSchema = __DIR__ . "/{$type}.json";

        $validator->validate($body, (object)['$ref' => "file://{$jsonSchema}"]);

        if (!$validator->isValid()) {
            throw BadRequest::createWithErrors($validator->getErrors());
        }
    }
}
