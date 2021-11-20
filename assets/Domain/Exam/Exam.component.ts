import { inject, injectable } from "inversify";
import ExamService from "./Exam.service";
import DatatableFactory from "../../Shared/factory/datatableFactory"
@injectable()
export default class ExamComponent {
    private examService: ExamService;
    constructor(
        @inject(ExamService) examService:ExamService,
        @inject(DatatableFactory) datatableFactory:DatatableFactory,
    ){
        this.examService=examService;
        let dataTable = datatableFactory.getDatatable('#exam_table', examService)
    }

}