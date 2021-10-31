import {Container} from "inversify";
import DatatableFactory from "./Shared/factory/datatableFactory";
import ReflevelService from "./Domain/RefLevel/reflevel.service";
import RefquestionService from "./Domain/RefQuestionType/refquestion.service";
import CategoryService from "./Domain/category/category.service";
import MainService from "./Shared/component/main/main.service";
import RefPosteService from './Domain/RefPoste/RefPoste.service';
import ExamService from './Domain/Exam/Exam.service';
import UserService from './Domain/User/User.service'
import TechnologyService from './Domain/Technology/Technology.service'
let container= new Container()
container.bind<ReflevelService>(ReflevelService).toSelf();
container.bind<CategoryService>(CategoryService).toSelf();
container.bind<RefquestionService>(RefquestionService).toSelf();
container.bind<DatatableFactory>(DatatableFactory).toSelf();
container.bind<MainService>(MainService).toSelf();
container.bind<RefPosteService>(RefPosteService).toSelf()
container.bind<ExamService>(ExamService).toSelf()
container.bind<UserService>(UserService).toSelf()
container.bind<TechnologyService>(TechnologyService).toSelf()
export default container;
