<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property string $id_ticket
 * @property string $user_id
 * @property string $category_id
 * @property string $prioritas
 * @property string $state
 * @property string $subject
 * @property string $description
 * @property string $attachment
 *
 * @property Chat[] $chats
 * @property Category $category
 * @property User $user
 */
class Ticket extends \yii\db\ActiveRecord
{
    public $bulan;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ticket', 'user_id', 'category_id', 'state', 'subject', 'description', 'date'], 'required'],
            [['id_ticket', 'user_id', 'category_id', 'support_id', 'jumlah'], 'integer'],
            [['prioritas', 'state'], 'string', 'max' => 10],
            [['subject'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 500],
            [['attachment'], 'file', 'skipOnEmpty' => true, 'extensions' => ['jpg','jpeg','png', 'pdf', 'doc', 'docx', 'xls', 'xlsx','JPG','JPEG','PNG','PDF', 'DOC', 'DOCX', 'XLS', 'XLSX'], 'message' => 'Ekstensi harus format JPG, JPEG, PNG, PDF, DOC, DOCX, XLS, XLSX!'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id_category']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ticket' => 'ID Ticket',
            'user_id' => 'User',
            'category_id' => 'Category',
            'prioritas' => 'Prioritas',
            'state' => 'State',
            'subject' => 'Subject',
            'description' => 'Description',
            'attachment' => 'Attachment',
            'support_id' => 'Support User',
            'date' => 'Date',
            'jumlah' => 'Jumlah',
        ];
    }

    public function beforeSave($insert) {
        if ($this->category_id == 6112017070836 AND $this->category_id == 6112017070900 AND $this->category_id == 6132017074554) {
            $this->prioritas = 'Tinggi';
        } elseif ($this->category_id == 6132017074600 AND $this->category_id == 6132017074451 AND $this->category_id == 6132017074539) {
            $this->prioritas = 'Sedang';
        } else {
            $this->prioritas = 'Rendah';
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::className(), ['ticket_id' => 'id_ticket']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id_category' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
