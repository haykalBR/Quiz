import {Container} from "inversify";
import DatatableFactory from "./Shared/factory/datatableFactory";
import RefquestionService from "./Domain/RefQuestionType/refquestion.service";
import CategoryService from "./Domain/category/category.service";
import MainService from "./Shared/component/main/main.service";
import ExamService from './Domain/Exam/Exam.service';
//IAM
import UserService from './Domain/User/User.service'
import PermissionsService from './Domain/Permissions/Permissions.service'
import RolesService from './Domain/Roles/Roles.service'
let container= new Container()
container.bind<CategoryService>(CategoryService).toSelf();
container.bind<RefquestionService>(RefquestionService).toSelf();
container.bind<DatatableFactory>(DatatableFactory).toSelf();
container.bind<MainService>(MainService).toSelf();
container.bind<ExamService>(ExamService).toSelf()
//IAM
container.bind<UserService>(UserService).toSelf()
container.bind<PermissionsService>(PermissionsService).toSelf()
container.bind<RolesService>(RolesService).toSelf()
export default container;
