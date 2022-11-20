<?php
namespace backend\web ;

use http\Exception\InvalidArgumentException;

class Student
{
    const TYPE_OCHN = 1;
    const TYPE_ZAOCH = 2;

    private $firstName;
    private $lastName;
    private $type;

    public static function getTypesList(): array
    {
        return[
            self::TYPE_OCHN => 'Очный',
            self::TYPE_ZAOCH => 'Заочный',
        ];
    }

    public function __construct($firstName, $lastName, $type)
    {
        if(!array_key_exists($type, self::getTypesList())){
            throw new InvalidArgumentException('Неверный тип!');
        }
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->type = $type;

    }
    public static function createOch($name, $lastname): Student
    {
        return new Student($name, $lastname, self::TYPE_OCHN);

    }
    public static function createZaoch($name, $lastname): Student
    {
        return new Student($name, $lastname, self::TYPE_ZAOCH);

    }

    public function getStatus(): string
    {
        return $this->type;
    }

    public function getFullName(): string
    {
        return $this->lastName . ' ' . $this->firstName . ' : ' . $this->getStatus() ;
    }


}

 //print_r(Student::getTypesList()) . PHP_EOL;

$student1 = Student::createOch('Денис', 'Чернягин');

$student2 = Student::createZaoch('Денис', 'Valov');

echo $student1->getFullName();
echo $student2->getFullName();

