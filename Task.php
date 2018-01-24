<?php

class Task implements TaskInterface
{
    public function run(): bool
    {
        usleep(random_int(10, 100) * 1000);
        return true;
    }

}