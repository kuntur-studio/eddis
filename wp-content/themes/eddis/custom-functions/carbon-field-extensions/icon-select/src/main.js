/**
 * External dependencies.
 */
import { Component, createRef } from '@wordpress/element';

class IconSelectField extends Component {
    constructor(props) {
        super(props);
        this.state = {
            isOpen: false,
        };
        this.selectRef = createRef();
    }

    /**
     * Maneja la selección de una opción.
     */
    handleSelect = (key) => {
        const { id, onChange } = this.props;
        onChange(id, key);
        this.setState({ isOpen: false });
    };

    /**
     * Alterna la visibilidad del dropdown.
     */
    toggleDropdown = () => {
        this.setState((prevState) => ({ isOpen: !prevState.isOpen }));
    };

    /**
     * Cierra el dropdown si se hace clic fuera.
     */
    handleClickOutside = (event) => {
        if (this.selectRef.current && !this.selectRef.current.contains(event.target)) {
            this.setState({ isOpen: false });
        }
    };

    componentDidMount() {
        document.addEventListener('mousedown', this.handleClickOutside);
    }

    componentWillUnmount() {
        document.removeEventListener('mousedown', this.handleClickOutside);
    }

    render() {
        const { id, name, value, field } = this.props;
        const { isOpen } = this.state;
        const options = field.options ? Object.entries(field.options) : [];
        const selectedLabel = options.find(([key]) => key === value)?.[1] || 'Seleccionar...';

        return (
            <div className="cf-icon-select" ref={this.selectRef}>
                {/* Botón que abre el dropdown */}
                <button type="button" className="cf-icon-select__button" onClick={this.toggleDropdown}>
                    <span dangerouslySetInnerHTML={{ __html: selectedLabel }} />
                    <span className="dashicons dashicons-arrow-down-alt2"></span>
                </button>

                {/* Dropdown de opciones */}
                {isOpen && (
                    <ul className="cf-icon-select__dropdown">
                        {options.map(([key, label]) => (
                            <li
                                key={key}
                                className={`cf-icon-select__option ${value === key ? 'selected' : ''}`}
                                onClick={() => this.handleSelect(key)}
                                dangerouslySetInnerHTML={{ __html: label }}
                            />
                        ))}
                    </ul>
                )}

                {/* Input oculto para almacenar el valor seleccionado */}
                <input type="hidden" id={id} name={name} value={value} />
            </div>
        );
    }
}

export default IconSelectField;