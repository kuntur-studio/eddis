const { createElement, useState, useEffect, useRef } = wp.element;

const SidebarProvinces = ({ data, activeProvince: propActiveProvince, onSelectBranch }) => {
  const [localActiveProvince, setLocalActiveProvince] = useState(null);
  const [isPopupOpen, setIsPopupOpen] = useState(false);
  const [isClosing, setIsClosing] = useState(false);
  const popupRef = useRef(null);
  const buttonRefs = useRef({});
  const timeoutRef = useRef(null);

  // Determina la provincia activa combinando la prop y el estado local
  const activeProvince = localActiveProvince || propActiveProvince;

  // Manejar clic fuera y tecla ESC
  useEffect(() => {
    const handleClickOutside = (event) => {
      if (activeProvince && 
          !popupRef.current?.contains(event.target) &&
          !buttonRefs.current[activeProvince]?.contains(event.target)) {
        closePopup();
      }
    };

    const handleKeyDown = (event) => {
      if (event.key === 'Escape' && activeProvince) {
        closePopup();
      }
    };

    document.addEventListener('mousedown', handleClickOutside, true);
    document.addEventListener('keydown', handleKeyDown);

    return () => {
      document.removeEventListener('mousedown', handleClickOutside, true);
      document.removeEventListener('keydown', handleKeyDown);
      clearTimeout(timeoutRef.current);
    };
  }, [activeProvince]);

  const closePopup = () => {
    setIsClosing(true);
    timeoutRef.current = setTimeout(() => {
      setIsPopupOpen(false);
      setIsClosing(false);
    }, 300); // Coincide con la duración de la animación CSS
  };

  const togglePopup = (province) => {
    if (activeProvince === province && isPopupOpen) {
      closePopup();
    } else {
      setLocalActiveProvince(province);
      setIsClosing(false);
      setIsPopupOpen(true);
    }
  };

  return createElement(
    "ul",
    { className: "nav flex-column nav-pills" },
    data.map((provinceData) => {
      const isActive = activeProvince === provinceData.province;
      const showPopup = (isActive && isPopupOpen) || isClosing;

      return createElement(
        "li",
        { 
          className: "nav-item", 
          key: provinceData.province 
        },
        createElement(
          "button",
          {
            className: `nav-link ${(activeProvince === provinceData.province) ? 'active' : ''}`,
            onClick: () => togglePopup(provinceData.province),
            "aria-expanded": isActive ? "true" : "false",
            ref: (el) => (buttonRefs.current[provinceData.province] = el),
            "aria-controls": `popup-${provinceData.province}`
          },
          provinceData.province
        ),
        showPopup &&
          createElement(
            "div",
            { 
              className: `popup ${isActive ? 'popup-enter' : 'popup-exit'}`,
              ref: isActive ? popupRef : null,
              id: `popup-${provinceData.province}`,
              role: "region",
              "aria-hidden": !isActive
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
                          tabIndex: isActive ? 0 : -1
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