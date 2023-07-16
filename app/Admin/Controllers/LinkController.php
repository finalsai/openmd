<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Link;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class LinkController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Link(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('url');
            $grid->column('sort');
            $grid->column('target');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Link(), function (Show $show) {
            $show->field('id');
            $show->field('id');
            $show->field('title');
            $show->field('url');
            $show->field('sort');
            $show->field('target');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Link(), function (Form $form) {
            $form->display('id');
            $form->text('title');
            $form->text('url');
            $form->number('sort')->default(0);
            $form->select('target')->options(['_self' => '_self', '_blank' => '_blank', '_parent' => '_parent', '_top' => '_top']);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
