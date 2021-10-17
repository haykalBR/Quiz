import {Container} from "inversify";
import DatatableFactory from "./Shared/factory/datatableFactory";
import ReflevelService from "./Domain/RefLevel/reflevel.service";
import CategoryService from "./Domain/category/category.service";
import MainService from "./Shared/component/main/main.service";
let container= new Container()
container.bind<ReflevelService>(ReflevelService).toSelf();
container.bind<CategoryService>(CategoryService).toSelf();
container.bind<DatatableFactory>(DatatableFactory).toSelf();
container.bind<MainService>(MainService).toSelf();
export default container;