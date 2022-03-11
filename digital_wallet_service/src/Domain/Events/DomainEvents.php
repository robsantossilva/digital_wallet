<?php

namespace Robsantossilva\DigitalWallet\Domain\Events;

trait DomainEvents
{

    private $observers = [];

    private function initDomainEvent($eventName)
    {
        if (!isset($this->observers[$eventName])) {
            $this->observers[$eventName] = [];
        }
    }

    private function getEventObservers(string $eventName): array
    {
        $this->initDomainEvent($eventName);
        return $this->observers[$eventName];
    }

    protected function registerObserver(ObserverInterface $observer, string $eventName): void
    {
        $this->initDomainEvent($eventName);
        $this->observers[$eventName][] = $observer;
    }

    protected function unregisterObserver(ObserverInterface $observer, string $eventName): void
    {
        foreach ($this->getEventObservers($eventName) as $key => $s) {
            if ($s === $observer) {
                unset($this->observers[$eventName][$key]);
            }
        }
    }

    protected function notifyObservers(string $eventName, $data = null): void
    {
        foreach ($this->getEventObservers($eventName) as $observer) {
            $observer->handle($this, $eventName, $data);
        }
    }
}
