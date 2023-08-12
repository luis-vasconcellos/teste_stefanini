<?php

namespace Drupal\saque\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements the SaqueForm form controller.
 *
 * @see \Drupal\Core\Form\FormBase
 */
class SaqueForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'saque_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['valor'] = [
      '#type' => 'number',
      '#title' => $this->t('Valor a ser sacado'),
      '#required' => TRUE,
      '#min' => 1,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Sacar'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $valor = $form_state->getValue('valor');
    $cedulas = [100, 50, 10, 5, 2, 1];
    $quantidades = [];

    foreach ($cedulas as $cedula) {
      if ($valor >= $cedula) {
        $quantidade = (int) ($valor / $cedula);
        $quantidades[$cedula] = $quantidade;
        $valor -= ($cedula * $quantidade);
      }
    }

    $result = [
      'valor' => $form_state->getValue('valor'),
      'quantidades' => $quantidades,
    ];

    $form_state->setRedirect('saque.result', ['result' => $result]);
  }
}