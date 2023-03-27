import ToggleContentViaFilterComponent from "../../../../../plugins/wwp-gutenberg-utils/includes/Bloc/ToggleContentViaFilterBlock/public/ToggleContentViaFilterComponent";

class TcvfComponent extends ToggleContentViaFilterComponent
{
  init() {
    this.debug = false;
    super.init();
  }
}

window.pew.addRegistryEntry({key: 'tcvf-component', domSelector: '.tcvf-block', classDef: TcvfComponent});
