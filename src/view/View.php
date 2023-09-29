<?php

namespace Jc\View;

interface View {
    public function render(string $view): string;
}