<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Model
 *
 * @property \App\Model\Table\PostsTable&\Cake\ORM\Association\HasMany $Posts
 * @property \App\Model\Table\CommentsTable&\Cake\ORM\Association\HasMany $Comments
 * @property \App\Model\Table\ProfilesTable&\Cake\ORM\Association\HasOne $Profile
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('email');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Posts', [
            'foreignKey' => 'user_id',
        ]);
        
        $this->hasMany('Comments', [
            'foreignKey' => 'user_id',
        ]);
        
        $this->hasOne('Profile', [
            'foreignKey' => 'user_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create')

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])

        $validator
            ->scalar('username')
            ->maxLength('username', 50)
            ->requirePresence('username', 'create')
            ->notEmptyString('username')
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 100)
            ->allowEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 100)
            ->allowEmptyString('last_name');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        $validator
            ->dateTime('last_login')
            ->allowEmptyDateTime('last_login');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        $rules->add($rules->isUnique(['username']), ['errorField' => 'username']);

        return $rules;
    }

    /**
     * Hash password before saving
     *
     * @param \Cake\Event\EventInterface $event Event instance
     * @param \App\Model\Entity\User $entity Entity instance
     * @param array $options Options
     * @return void
     */
    public function beforeSave($event, $entity, $options)
    {
        if ($entity->isNew() || $entity->isDirty('password')) {
            $hasher = new DefaultPasswordHasher();
            $entity->password = $hasher->hash($entity->password);
        }
    }

    /**
     * Find active users
     *
     * @param \Cake\ORM\Query $query Query instance
     * @param array $options Options
     * @return \Cake\ORM\Query
     */
    public function findActive($query, array $options)
    {
        return $query->where(['is_active' => true]);
    }

    /**
     * Find users by role
     *
     * @param \Cake\ORM\Query $query Query instance
     * @param array $options Options
     * @return \Cake\ORM\Query
     */
    public function findByRole($query, array $options)
    {
        if (isset($options['role'])) {
            return $query->where(['role' => $options['role']]);
        }
        return $query;
    }

    /**
     * Get user with profile and posts
     *
     * @param int $id User ID
     * @return \App\Model\Entity\User|null
     */
    public function getUserWithProfile($id)
    {
        return $this->get($id, [
            'contain' => ['Profile', 'Posts' => ['sort' => ['Posts.created' => 'DESC']]]
        ]);
    }
}
