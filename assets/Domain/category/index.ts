import container from '../../Container';
import CategoryComponent from "./category.component";
let categoryComponent:CategoryComponent;
categoryComponent=container.resolve<CategoryComponent>(CategoryComponent);
categoryComponent.deleteLevel();
categoryComponent.changeStateLevel();
