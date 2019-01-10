<?php

namespace App;

class Role
{
    public $subscriber = [
        'id' => 'subscriber',
        'name' => 'Subscriber',
        'can' => [],
        'description' => '',
    ];
    public $contributor = [
        'id' => 'contributor',
        'name' => 'Contributor',
        'can' => ['view'],
        'description' => '',
    ];
    public $author = [
        'id' => 'author',
        'name' => 'Author',
        'can' => ['view', 'create', 'update', 'delete', 'restore'],
        'description' => '',
    ];
    public $editor = [
        'id' => 'editor',
        'name' => 'Editor',
        'can' => ['view', 'update', 'delete', 'restore'],
        'description' => '',
    ];
    public $administrator = [
        'id' => 'administrator',
        'name' => 'Administrator',
        'can' => ['view', 'create', 'update', 'delete', 'restore', 'forceDelete'],
        'description' => '',
    ];

    public function isValidRole($roleId)
    {
        return \in_array($roleId, [
            $this->subscriber['id'],
            $this->contributor['id'],
            $this->author['id'],
            $this->editor['id'],
            $this->administrator['id'],
        ]);
    }
    public function isSubscriber($roleId)
    {
        return $roleId == $this->subscriber['id'];
    }
    public function isContributor($roleId)
    {
        return $roleId == $this->contributor['id'];
    }
    public function isAuthor($roleId)
    {
        return $roleId == $this->author['id'];
    }
    public function isEditor($roleId)
    {
        return $roleId == $this->editor['id'];
    }
    public function isAdministrator($roleId)
    {
        return $roleId == $this->administrator['id'];
    }

    public function can(User $user, $action)
    {
        $option = $this->toOption();
        $role = $option[$user->role];
        return \in_array($action, $role['can']);
    }

    public function toOption()
    {
        return [
            $this->subscriber['id'] => $this->subscriber,
            $this->contributor['id'] => $this->contributor,
            $this->author['id'] => $this->author,
            $this->editor['id'] => $this->editor,
            $this->administrator['id'] => $this->administrator,
        ];
    }

    public function toIdName()
    {
        $option = $this->toOption();
        $idNames = [];
        foreach ($option as $roleId => $role) {
            $idNames[$roleId] = $role['name'];
        }
        return $idNames;
    }

    public function getName($roleId)
    {
        $option = $this->toOption();
        return isset($option[$roleId]) ? $option[$roleId]['name'] : null;
    }
}
