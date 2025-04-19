const { createElement } = wp.element;

const SidebarProvinces = ({ data, onSelectBranch }) => {
    return createElement(
        "ul",
        { className: "nav flex-column nav-pills" },
        data.map((provinceData) =>
            createElement(
                "li",
                { className: "nav-item dropdown", key: provinceData.province },
                createElement(
                    "a",
                    {
                        className: "nav-link dropdown-toggle",
                        "data-bs-toggle": "dropdown",
                        href: "#",
                        role: "button",
                        "aria-expanded": "false",
                    },
                    provinceData.province
                ),
                createElement(
                    "div",
                    { className: "dropdown-menu" },
                    provinceData.cities.map((cityData) =>
                        createElement(
                            "div",
                            { key: cityData.name },
                            createElement(
                                "h6",
                                { className: "dropdown-header" },
                                cityData.name
                            ),
                            cityData.branches.map((branchData) =>
                                createElement(
                                    "a",
                                    {
                                        key: branchData.id,
                                        className: "dropdown-item",
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
    );
};

export default SidebarProvinces;