const { Component, createElement } = wp.element;
import SidebarProvinces from "./SidebarProvinces";
import ContentBranch from "./ContentBranch";

class BranchesWidget extends Component {
  constructor(props) {
    super(props);
    const initialBranch = this.findLujanBranch(props.data);
    
    this.state = {
      activeBranch: initialBranch.branch,
      activeProvince: initialBranch.province,
      animationKey: 0
    };
  }

  findLujanBranch = (data) => {
    // Buscar en todas las provincias
    for (const provinceData of data) {
      // Buscar en todas las ciudades de cada provincia
      for (const cityData of provinceData.cities) {
        // Buscar la sucursal Luján (ID 711)
        const lujanBranch = cityData.branches.find(b => b.id === 711);
        if (lujanBranch) {
          return {
            branch: lujanBranch,
            province: provinceData.province
          };
        }
      }
    }
    // Si no encuentra Luján, devolver null
    return { branch: null, province: null };
  };

  setActiveBranch = (branch, province) => {
    this.setState({ 
      activeBranch: branch,
      activeProvince: province,
      animationKey: this.state.animationKey + 1
    });
  };

  render() {
    const { data } = this.props;
    const { activeBranch, activeProvince, animationKey } = this.state;

    return createElement(
      "div",
      { className: "container" },
      createElement(
        "div",
        { className: "row" },
        createElement(
          "div",
          { className: "col-xl-2 col-lg-2 col-sm-4 col-md-4 col-xs-12 col-12" },
          createElement(SidebarProvinces, {
            data,
            activeProvince: activeProvince,
            onSelectBranch: this.setActiveBranch,
          })
        ),
        createElement(
          "div",
          { className: "col-xl-10 col-lg-10 col-sm-8 col-md-8 col-xs-12 col-12" },
          createElement(ContentBranch, { 
            branch: activeBranch,
            province: activeProvince,
            animationKey: animationKey
          })
        )
      )
    );
  }
}

export default BranchesWidget;