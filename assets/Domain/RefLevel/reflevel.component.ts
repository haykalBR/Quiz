import { inject, injectable } from "inversify";
import ReflevelService from "./reflevel.service";
import DatatableFactory from "../../Shared/factory/datatableFactory"
@injectable()
export default class ReflevelComponent {
    private levelService: ReflevelService;
    constructor(
        @inject(ReflevelService) levelService:ReflevelService,
        @inject(DatatableFactory) datatableFactory:DatatableFactory,
    ){
        this.levelService=levelService;
        datatableFactory.getDatatable('#reflevel_table', levelService)
    }

    deleteLevel():void{
        $("#reflevel_table").on('click', '.delete',this.levelService.deleteLevel);
    }
    changeStateLevel():void{
        $("#reflevel_table").on('click', '.switch-input',this.levelService.changeState);
    }
}