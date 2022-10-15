<?php declare(strict_types = 1);

namespace App\EntityToString\Solution;

use PHPUnit\Framework\TestCase;

class FooTest extends TestCase
{

    public function testEntityExistsViaArrayFunctions(): void
    {
        $entity1 = new Foo();
        $entity2 = new Foo();

        $listOfEntities = [$entity1, $entity2, $entity2];

        try {
            $uniqueList = array_unique($listOfEntities);
            self::fail('Should fail on Error: Object of class App\EntityToString\Solution\Foo could not be converted to string.');
        } catch (\Error $e) {
            self::assertTrue(true);
        }
    }

}
