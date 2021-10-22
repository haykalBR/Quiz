import { inject, injectable } from "inversify";
import RefquestionService from "./refquestion.service";
import DatatableFactory from "../../Shared/factory/datatableFactory"
@injectable()
export default class RefquestiontypeComponent {
    private levelService: RefquestionService;
    constructor(
        @inject(RefquestionService) levelService:RefquestionService,
        @inject(DatatableFactory) datatableFactory:DatatableFactory,
    ){
        this.levelService=levelService;
        datatableFactory.getDatatable('#questiontype_table', levelService)
    }

    deleteLevel():void{
        $("#questiontype_table").on('click', '.delete',this.levelService.deleteLevel);
    }
    changeStateLevel():void{
        $("#questiontype_table").on('click', '.switch-input',this.levelService.changeState);
    }
}