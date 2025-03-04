export default function SuccessButton({
    className = "",
    disabled,
    children,
    ...props
}) {
    return (
        <button
            {...props}
            className={
                `inline-flex items-center px-2 py-2 bg-none border border-transparent rounded-md font-semibold text-xs text-gray-50 hover:text-white uppercase tracking-widest bg-green-600 hover:bg-green-700 transition ease-in-out duration-150 
                  
                ${disabled && "opacity-25"}` + className
            }
            disabled={disabled}
        >
            {children}
        </button>
    );
}
