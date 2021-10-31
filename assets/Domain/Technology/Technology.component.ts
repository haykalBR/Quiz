import { inject, injectable } from "inversify";
import TechnologyService from "./Technology.service";
import DatatableFactory from "../../Shared/factory/datatableFactory"
@injectable()
export default class TechnologyComponent {
    private technologyService: TechnologyService;
    constructor(
        @inject(TechnologyService) technologyService:TechnologyService,
        @inject(DatatableFactory) datatableFactory:DatatableFactory,
    ){
        this.technologyService=technologyService;
        let dataTable = datatableFactory.getDatatable('#technology_table', technologyService)
    }

}