import {Container} from "inversify";
import DatatableFactory from "./Shared/factory/datatableFactory";
import ReflevelService from "./Domain/RefLevel/reflevel.service";
let container= new Container()
container.bind<ReflevelService>(ReflevelService).toSelf();
container.bind<DatatableFactory>(DatatableFactory).toSelf();
export default container;