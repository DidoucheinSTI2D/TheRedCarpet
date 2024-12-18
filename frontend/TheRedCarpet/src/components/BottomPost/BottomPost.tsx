import React, { useState } from 'react';



const Test = ({likes, description}) => {

    const maxLength = 20;

    const [isExpanded, setIsExpanded] = useState(false);

    const isTruncatable = description.length > maxLength;

    const toggleExpand = () => {
        setIsExpanded(!isExpanded);
    };

    const displayedText = isExpanded || !isTruncatable ? description : description.slice(0, maxLength);


    return (
        <div className="flex flex-col justify-between pb-2 gap-[2rem] cursor-pointer" onClick={toggleExpand} > 
            <div className='flex flex-col gap-[1rem]' >
                <div className='flex flex-wrap items-center justify-start gap-[.1rem]'>
                    <p className=" text-lg transition-all duration-300">
                    {displayedText}
                    {!isExpanded && isTruncatable && '...'}
                    </p>
                    {isTruncatable && (
                        <button
                        onClick={toggleExpand}
                        className="text-black-500 underline"
                        >
                        {isExpanded ? 'See less' : 'See more'}
                        </button>
                    )}
                </div>
            </div>
        </div>
    );
};

export default Test;