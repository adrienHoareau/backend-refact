<?php

interface PlaceholdersReplacer
{
    public function replace(string $text, array $data): string;
}
