const { Component, createElement } = wp.element;
import SidebarProvinces from "./SidebarProvinces";
import ContentBranch from "./ContentBranch";

class BranchesWidget extends Component {
    constructor(props) {
      super(props);
      this.state = {
        activeBranch: null,
        activeProvince: null,
        animationKey: 0 // Añadimos un contador para animaciones
      };
    }
  
    setActiveBranch = (branch, province) => {
      this.setState({ 
        activeBranch: branch,
        activeProvince: province,
        animationKey: this.state.animationKey + 1 // Incrementamos con cada cambio
      });
    };
  
    render() {
        const { data } = this.props;
        const { activeBranch, activeProvince } = this.state;

        return createElement(
        "div", // Contenedor principal
        { className: "container" },
        createElement(
            "div", // Fila (row)
            { className: "row" },
            createElement(
                "div", // Columna para SidebarProvinces
                { className: "col-xl-2 col-lg-2 col-sm-4 col-md-4 col-xs-12 col-12" },
                createElement(SidebarProvinces, { data, onSelectBranch: this.setActiveBranch })
            ),
            createElement(
                "div", // Columna para ContentBranch
                { className: "col-xl-10 col-lg-10 col-sm-8 col-md-8 col-xs-12 col-12" },
                createElement(ContentBranch, { 
                    branch: activeBranch,
                    province: activeProvince,
                    animationKey: this.state.animationKey // Pasamos la clave
                })
            )
        )
    );
    }
}

export default BranchesWidget;