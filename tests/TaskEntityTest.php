<?php

namespace App\Tests;

use App\Entity\Task;
use PHPUnit\Framework\TestCase;

class TaskEntityTest extends TestCase
{
    private $task;
   
    public function setUp(): void
    {
       $this->task = new Task();
    }
    public function testId(): void
    {
        $this->assertNull($this->task->getId());
    }

    public function testTitle():void
    {
        $this->task->setTitle('test');
        $this->assertSame('test',$this->task->getTitle());

    }
    public function testContent():void
    {
        $this->task->setContent('lorem');
        $this->assertSame('lorem',$this->task->getContent());

    }

    public function testisDone():void
    {
        $this->task->setIsDone(true);
        $this->assertSame(true,$this->task->isDone());


    }
   
    public function testCreatedAt()
    {
        $date = new \DateTime();
        $this->task->setCreatedAt($date);
        $this->assertSame($date, $this->task->getCreatedAt());
    }

}