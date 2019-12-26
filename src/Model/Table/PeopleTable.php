<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PeopleTable extends Table
{
    /**
     * Undocumented function
     * @param array $config test
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setDisplayField('name');
        $this->hasMany('Messages');
    }

    /**
     * Undocumented function
     *
     * @param Query $query test
     * @param array $options test
     * @return mixed
     */
    public function findMe(Query $query, array $options)
    {
        $me = $options['me'];

        return $query->where(['name like' => '%' . $me . '%'])
        ->orWhere(['mail like' => '%' . $me . '%'])
        ->order(['age' => 'asc']);
    }

    /**
     * Undocumented function
     *
     * @param Query $query test
     * @param array $options test
     * @return mixed
     */
    public function findByAge(Query $query, array $options)
    {
        return $query->order(['age' => 'asc'])->order(['name' => 'asc']);
    }

    /**
     * Undocumented function
     *
     * @param Validator $validator test
     * @return mixed
     */
    public function validationDefault(Validator $validator)
    {
        $validator->integer('id', 'idは整数で入力下さい。')->allowEmpty('id', 'create');

        $validator->scalar('name', 'テキストを入力下さい。')->requirePresence('name', 'create')->notEmpty('name', '名前は必ず記入下さい。');

        $validator->scalar('mail', 'テキストを入力下さい。')->allowEmpty('mail')->email('mail', false, 'メールアドレスを記入して下さい。');

        $validator->integer('age', '整数を入力下さい。')->requirePresence('age', 'create')->notEmpty('age', '必ず値を入力下さい。')->greaterThan('age', -1, 'ゼロ以上の値を記入下さい。');

        return $validator;
    }
}
