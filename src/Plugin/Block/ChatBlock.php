<?php

namespace Drupal\codimth_chat_nodejs_drupal\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\user\Entity\User;

/**
 *
 * @Block(
 *   id = "chat_block",
 *   admin_label = @Translation("Chat block"),
 *   category = @Translation("Codimth"),
 * )
 */
class ChatBlock extends BlockBase implements BlockPluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $uid = \Drupal::currentUser()->id();
        $current_user = User::load($uid);

        $ids = \Drupal::entityQuery('user')
            ->condition('status', 1)
            ->condition('uid', $uid, '<>')
            ->execute();
        $users = User::loadMultiple($ids);

        return array(
            '#theme' => 'chat',
            '#users' => $users,
            '#attached' => [
                'library' => [
                    'codimth_chat_nodejs_drupal/scripts',
                ],
                'drupalSettings' => [
                    'current_user' => [
                        'uid' => $current_user->get('uid')->value,
                        'name' => $current_user->get('name')->value,
                        ],
                ]
            ],

        );
    }


}
