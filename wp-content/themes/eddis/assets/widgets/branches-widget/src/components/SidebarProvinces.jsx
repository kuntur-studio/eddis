
const { createElement, useState, useEffect, useRef } = wp.element;

const SidebarProvinces = ({ data, activeProvince: initialActiveProvince, onSelectBranch }) => {
  const [localActiveProvince, setLocalActiveProvince] = useState(null);
  const [popupProvince, setPopupProvince] = useState(null);
  const popupRef = useRef(null);
  const buttonRefs = useRef({});

  const activeProvince = localActiveProvince || initialActiveProvince;

  useEffect(() => {
    const handleClickOutside = (event) => {
      if (
        popupProvince &&
        !popupRef.current?.contains(event.target) &&
        !buttonRefs.current[popupProvince]?.contains(event.target)
      ) {
        closePopup();
      }
    };

    const handleKeyDown = (event) => {
      if (event.key === 'Escape' && popupProvince) {
        closePopup();
      }
    };

    document.addEventListener('mousedown', handleClickOutside, true);
    document.addEventListener('keydown', handleKeyDown);

    return () => {
      document.removeEventListener('mousedown', handleClickOutside, true);
      document.removeEventListener('keydown', handleKeyDown);
    };
  }, [popupProvince]);

  const closePopup = () => {
    setPopupProvince(null);
  };

  const togglePopup = (province) => {
    if (popupProvince === province) {
      closePopup();
    } else {
      setLocalActiveProvince(province);
      setPopupProvince(province);
    }
  };

  return createElement(
    "ul",
    { className: "nav flex-column nav-pills" },
    data.map((provinceData) => {
      const isActive = activeProvince === provinceData.province;
      const isPopupVisible = popupProvince === provinceData.province;

      return createElement(
        "li",
        { 
          className: "nav-item", 
          key: provinceData.province 
        },
        createElement(
          "button",
          {
            className: `nav-link ${isActive ? 'active' : ''}`,
            onClick: () => togglePopup(provinceData.province),
            "aria-expanded": isPopupVisible ? "true" : "false",
            ref: (el) => (buttonRefs.current[provinceData.province] = el),
            "aria-controls": `popup-${provinceData.province}`
          },
          provinceData.province
        ),
        isPopupVisible &&
          createElement(
            "div",
            { 
              className: "popup popup-enter",
              ref: popupRef,
              id: `popup-${provinceData.province}`,
              role: "region",
              "aria-hidden": false
            },
            createElement(
              "div",
              { className: "popup-content" },
              createElement(
                "div",
                { className: "cities-grid" },
                provinceData.cities.map((cityData) =>
                  createElement(
                    "div",
                    { key: cityData.name, className: "city-group" },
                    cityData.branches.map((branchData) =>
                      createElement(
                        "a",
                        {
                          key: branchData.id,
                          className: "popup-item",
                          onClick: (e) => {
                            e.preventDefault();
                            onSelectBranch(branchData, provinceData.province);
                            closePopup();
                          },
                          href: `#${branchData.id}`,
                          tabIndex: isPopupVisible ? 0 : -1
                        },
                        branchData.title
                      )
                    )
                  )
                )
              )
            )
          )
      );
    })
  );
};

export default SidebarProvinces;