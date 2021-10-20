import { inject, injectable } from "inversify";
import CategoryService from "./category.service";
import DatatableFactory from "../../Shared/factory/datatableFactory"
@injectable()
export default class CategoryComponent {
    private categoryService: CategoryService;
    constructor(
        @inject(CategoryService) categoryService:CategoryService,
        @inject(DatatableFactory) datatableFactory:DatatableFactory,
    ){
        this.categoryService=categoryService;
        let dataTable = datatableFactory.getDatatable('#category_table', categoryService)
        this.Search(dataTable);
    }
    private Search(dataTable):void{
        $('#categories_search_search_public').on("change",dataTable.draw);
    }
    deleteLevel():void{
        $("#category_table").on('click', '.delete',this.categoryService.deleteLevel);
    }
    changeStateLevel():void{
        $("#category_table").on('click', '.switch-input',this.categoryService.changeState);
    }
}