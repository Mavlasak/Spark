<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\Model;

class HomepagePresenter extends Nette\Application\UI\Presenter {

    private $Model;

    public function __construct(Model $Model) {
        $this->Model = $Model;
    }

    public function createComponentZadejID() {
        $form = new Form();
        $form->addText('id')
                ->setRequired('Zadejte prosím id produktu.')
                ->addRule(Form::INTEGER)
                ->addRule(Form::MAX_LENGTH, 'Zadat můžete maximálně %d znaků', 3);
        $form->addSubmit('submit', 'OK');
        $form->onSuccess[] = [$this, 'ZadejIDSucceeded'];
        return $form;
    }

    public function ZadejIDSucceeded(Form $form) {
        $values = $form->getValues();
        $this->detail($values['id']);
    }

    public function detail($id) {
        $value = $this->Model->getProduct($id);
        return $this->sendJson($value);
    }

}
