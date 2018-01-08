<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property string $id_chat
 * @property string $waktu
 * @property string $ticket_id
 * @property string $nama
 * @property string $chat
 *
 * @property Ticket $ticket
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_chat', 'waktu', 'ticket_id', 'nama', 'chat'], 'required'],
            [['id_chat', 'ticket_id'], 'integer'],
            [['waktu'], 'string', 'max' => 100],
            [['nama'], 'string', 'max' => 50],
            [['chat'], 'string', 'max' => 500],
            [['ticket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::className(), 'targetAttribute' => ['ticket_id' => 'id_ticket']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_chat' => 'ID Chat',
            'waktu' => 'Waktu',
            'ticket_id' => 'ID Ticket',
            'nama' => 'Nama',
            'chat' => 'Chat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Ticket::className(), ['id_ticket' => 'ticket_id']);
    }
}
