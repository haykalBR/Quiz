import { inject, injectable } from "inversify";
import ReflevelService from "./reflevel.service";
import DatatableFactory from "../../Shared/factory/datatableFactory"

@injectable()
export default class ReflevelComponent {
    private reflevelService: ReflevelService;
    constructor(
        @inject(ReflevelService) reflevelService:ReflevelService,
        @inject(DatatableFactory) datatableFactory:DatatableFactory,
    ){
        datatableFactory.getDatatable('#reflevel_table', reflevelService)
    }
}