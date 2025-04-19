const { createElement } = wp.element;

const ContentBranch = ({ branch }) => {
    if (!branch) {
        return createElement("p", null, "Selecciona una sede para ver los detalles.");
    }

    return createElement(
        "div",
        { className: "branch-content" },
        createElement("h4", null, branch.title),
        createElement("p", null, `Dirección: ${branch.address}`),
        createElement("p", null, `Teléfono: ${branch.phone}`),
        branch.email &&
            createElement(
                "a",
                { href: `mailto:${branch.email}` },
                `Email: ${branch.email}`
            ),
        branch.mapa &&
            createElement("iframe", {
                src: branch.mapa,
                width: "100%",
                height: "450",
                style: { border: 0 },
                allowFullScreen: true,
                loading: "lazy",
            })
    );
};

export default ContentBranch;
