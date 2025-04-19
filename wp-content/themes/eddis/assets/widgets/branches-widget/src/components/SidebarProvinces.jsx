const { createElement, useState } = wp.element;

const SidebarProvinces = ({ data, onSelectBranch }) => {
    const [activeProvince, setActiveProvince] = useState(null);

    const togglePopup = (province) => {
        setActiveProvince(activeProvince === province ? null : province);
    };

    return createElement(
        "ul",
        { className: "nav flex-column nav-pills" },
        data.map((provinceData) =>
            createElement(
                "li",
                { className: "nav-item", key: provinceData.province },
                createElement(
                    "button",
                    {
                        className: "nav-link",
                        onClick: () => togglePopup(provinceData.province),
                        "aria-expanded": activeProvince === provinceData.province ? "true" : "false",
                    },
                    provinceData.province
                ),
                activeProvince === provinceData.province &&
                    createElement(
                        "div",
                        { className: "popup" },
                        createElement(
                            "div",
                            { className: "popup-content" },
                            createElement(
                                "button",
                                {
                                    className: "close-btn",
                                    onClick: () => setActiveProvince(null),
                                },
                                "×"
                            ),
                            createElement(
                                "div",
                                { className: "cities-grid" },
                                provinceData.cities.map((cityData) =>
                                    createElement(
                                        "div",
                                        { key: cityData.name, className: "city-group" },
                                        createElement("h6", { className: "popup-header" }, cityData.name),
                                        cityData.branches.map((branchData) =>
                                            createElement(
                                                "a",
                                                {
                                                    key: branchData.id,
                                                    className: "popup-item",
                                                    onClick: () => onSelectBranch(branchData),
                                                    href: `#${branchData.id}`,
                                                },
                                                branchData.title
                                            )
                                        )
                                    )
                                )
                            )
                        )
                    )
            )
        )
    );
};

export default SidebarProvinces;