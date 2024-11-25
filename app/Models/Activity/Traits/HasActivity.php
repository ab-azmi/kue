<?php

namespace App\Models\Activity\Traits;

use App\Services\Constant\Activity\ActivityType;
use Illuminate\Support\Str;

use function activity;
use function now;

trait HasActivity
{
    /**
     * @var string
     */
    protected $activityType = '';

    /**
     * @var string
     */
    protected $activityAction = '';

    /**
     * @var array
     */
    protected $activityProperties = [
        'old' => null,
        'new' => null,
    ];

    abstract public function getActivityType(): string;

    abstract public function getActivitySubType(): string;

    public function getActivityProperties()
    {
        return $this->activityProperties;
    }

    public function saveActivity(?string $description = null)
    {
        $type = ActivityType::GENERAL;
        if (method_exists($this, 'getActivityType')) {
            $type = $this->getActivityType();
        }

        $subType = '';
        if (method_exists($this, 'getActivitySubType')) {
            $subType = $this->getActivitySubType();
        }

        return activity()->setType($type)
            ->setSubType($subType)
            ->setAction($this->activityAction)
            ->setReference($this)
            ->setProperties($this->activityProperties)
            ->setCreatedAt(now())
            ->log($description);
    }

    public function withActivityProperty(array $property, ?string $key = null)
    {
        if (! $key) {
            $this->activityProperties = array_merge($this->activityProperties, $property);
        } else {
            $this->activityProperties[$key] = $property;
        }

        return $this;
    }

    public function setActivityPropertyAttributes(string $action, ?string $customMethod = null, ?array $others = null)
    {
        $this->activityAction = $action;

        if ($others) {
            $this->withActivityProperty($others, 'others');
        }

        $this->withActivityProperty($this->processGettingAttributes($action, $customMethod), 'new');

        return $this;
    }

    public function setOldActivityPropertyAttributes(string $action, ?string $customMethod = null, ?array $others = null)
    {
        $this->activityAction = $action;

        if ($others) {
            $this->withActivityProperty($others, 'others');
        }

        $this->withActivityProperty($this->processGettingAttributes($action, $customMethod), 'old');

        return $this;
    }

    /** --- FUNCTIONS --- */
    private function processGettingAttributes(string $action, ?string $customMethod = null)
    {
        $method = 'getActivityProperty';
        $method .= str_replace('_', '', Str::title($action));

        if ($customMethod) {
            $method .= Str::ucfirst($customMethod);
        }

        return $this->$method();
    }
}
