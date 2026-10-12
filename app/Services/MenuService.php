<?php

namespace App\Services;

class MenuItem
{
    public function __construct(
        public string $label,
        public string $icon,
        public string $route,
        public string $section,
        public string $activePattern = '',
    ) {
        if (!$this->activePattern) {
            $this->activePattern = str_replace('.', '.', $route) . '.*';
        }
    }
}

class MenuSection
{
    public string $label;
    public string $id;
    /** @var MenuItem[] */
    public array $items = [];

    public function __construct(string $label, string $id)
    {
        $this->label = $label;
        $this->id = $id;
    }

    public function addItem(MenuItem $item): void
    {
        $this->items[] = $item;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}

class MenuService
{
    /** @var MenuSection[] */
    private array $sections = [];

    public function __construct()
    {
        $this->registerDefaultSections();
    }

    private function registerDefaultSections(): void
    {
        $this->sections = [
            'people' => new MenuSection('الأشخاص', 's-people'),
            'academics' => new MenuSection('الدراسة', 's-academics'),
            'subjects' => new MenuSection('المواد والمنهاج', 's-subjects'),
            'attendance' => new MenuSection('الحضور', 's-attendance'),
            'finance' => new MenuSection('المالية', 's-finance'),
            'timetable' => new MenuSection('جدول الحصص', 's-timetable'),
            'communication' => new MenuSection('المراسلات', 's-communication'),
            'hostel' => new MenuSection('الإيواء والنقل', 's-hostel'),
            'exams' => new MenuSection('الامتحانات', 's-exams'),
            'datatransfer' => new MenuSection('استيراد وتصدير', 's-datatransfer'),
            'rbac' => new MenuSection('الإدارة', 's-rbac'),
            'system' => new MenuSection('النظام', 's-system'),
        ];
    }

    public function addItem(string $section, MenuItem $item): void
    {
        if (!isset($this->sections[$section])) {
            $this->sections[$section] = new MenuSection(ucfirst($section), 's-' . $section);
        }
        $this->sections[$section]->addItem($item);
    }

    public function addSection(string $key, MenuSection $section): void
    {
        $this->sections[$key] = $section;
    }

    public function getSection(string $key): ?MenuSection
    {
        return $this->sections[$key] ?? null;
    }

    public function getSections(): array
    {
        return $this->sections;
    }

    public function hasSection(string $key): bool
    {
        return isset($this->sections[$key]);
    }
}
