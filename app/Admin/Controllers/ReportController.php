<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Report;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\Tools\BatchActions;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ReportController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(Report::with('content'), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('content.slug', 'Markdown');
            $grid->column('ip');
            $grid->column('useragent');
            $grid->column('referrer');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });

            $grid->disableCreateButton();
            $grid->disableEditButton();
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
        return Show::make($id, new Report(), function (Show $show) {
            $show->field('id');
            $show->field('content_id');
            $show->field('ip');
            $show->field('useragent');
            $show->field('referrer');
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
        return Form::make(new Report(), function (Form $form) {
            $form->display('id');
            $form->text('content_id');
            $form->text('ip');
            $form->text('useragent');
            $form->text('referrer');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
