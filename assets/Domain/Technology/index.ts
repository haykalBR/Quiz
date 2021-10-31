import container from '../../Container';
import TechnologyComponent from "./Technology.component";
let technologyComponent:TechnologyComponent;
technologyComponent=container.resolve<TechnologyComponent>(TechnologyComponent);

