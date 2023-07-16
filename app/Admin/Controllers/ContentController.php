<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Content;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ContentController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Content(), function (Grid $grid) {
            $grid->model()->withCount('reports');
            $grid->column('id')->sortable();
            $grid->column('slug')->filter();
            $grid->column('view_count', '浏览次数');
            $grid->column('reports_count', '举报')->sortable();
            // $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });

            $grid->disableViewButton();
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
        return Show::make($id, new Content(), function (Show $show) {
            $show->field('id');
            $show->field('id');
            $show->field('slug');
            $show->field('view_count');
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
        return Form::make(new Content(), function (Form $form) {
            $form->display('id');
            $form->text('slug');
            $form->text('view_count');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
