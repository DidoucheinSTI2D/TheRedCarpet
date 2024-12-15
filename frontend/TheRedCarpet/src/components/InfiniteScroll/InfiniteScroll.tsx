import React from 'react';

import { useEffect, useRef, useState } from "react";
import { useInView } from "react-intersection-observer";
import Post from "../Post/Post"
import { getOngoingRepresentations } from "@/api/API";


const fetchRepresentations = async () => {
    const result = await getOngoingRepresentations();

    if (!result.error) {
        console.log("Ongoing Representations:", result.data);
    } else {
        console.error("Error fetching representations:", result.message);
    }
    console.log(result)

};


const people = [
    { name: "John Doe", description: "Test", likes: 12 },
    { name: "Jane Smith", description: "Lorem ipsum dolor sit amet.", likes: 25 },
    { name: "Alice Johnson", description: "Consectetur adipiscing elit.", likes: 30 },
    { name: "Bob Brown", description: "Sed do eiusmod tempor incididunt.", likes: 18 },
    { name: "Charlie Davis", description: "Ut labore et dolore magna aliqua.", likes: 22 },
    { name: "Diana Evans", description: "Ut enim ad minim veniam.", likes: 15 },
    { name: "Ethan Foster", description: "Quis nostrud exercitation ullamco laboris.", likes: 10 },
    { name: "Fiona Green", description: "Nisi ut aliquip ex ea commodo consequat.", likes: 28 },
    { name: "George Harris", description: "Duis aute irure dolor in reprehenderit.", likes: 5 },
    { name: "Hannah Ivers", description: "In voluptate velit esse cillum dolore.", likes: 20 },
    { name: "Isabella King", description: "Excepteur sint occaecat cupidatat non proident.", likes: 17 },
    { name: "Jack Lee", description: "Sunt in culpa qui officia deserunt mollit anim.", likes: 14 },
    { name: "Katherine Moore", description: "Laboris nisi ut aliquip ex ea commodo.", likes: 19 },
    { name: "Liam Nelson", description: "Duis aute irure dolor in reprehenderit in voluptate.", likes: 11 },
    { name: "Mia O'Connor", description: "Velit esse cillum dolore eu fugiat nulla pariatur.", likes: 23 },
    { name: "Noah Parker", description: "At vero eos et accusamus et iusto odio dignissimos.", likes: 9 },
    { name: "Olivia Quinn", description: "Tempor incididunt ut labore et dolore magna aliqua.", likes: 26 },
    { name: "Paul Roberts", description: "Ut enim ad minim veniam, quis nostrud exercitation.", likes: 8 },
    { name: "Quinn Smith", description: "Excepteur sint occaecat cupidatat non proident.", likes: 29 },
    { name: "Rachel Taylor", description: "Sed ut perspiciatis unde omnis iste natus error.", likes: 16 },
    { name: "Samuel Underwood", description: "Nemo enim ipsam voluptatem quia voluptas.", likes: 7 },
    { name: "John Doe", description: "Test", likes: 12 },
    { name: "Jane Smith", description: "Lorem ipsum dolor sit amet.", likes: 25 },
    { name: "Alice Johnson", description: "Consectetur adipiscing elit.", likes: 30 },
    { name: "Bob Brown", description: "Sed do eiusmod tempor incididunt.", likes: 18 },
    { name: "Charlie Davis", description: "Ut labore et dolore magna aliqua.", likes: 22 },
    { name: "Diana Evans", description: "Ut enim ad minim veniam.", likes: 15 },
    { name: "Ethan Foster", description: "Quis nostrud exercitation ullamco laboris.", likes: 10 },
    { name: "Fiona Green", description: "Nisi ut aliquip ex ea commodo consequat.", likes: 28 },
    { name: "George Harris", description: "Duis aute irure dolor in reprehenderit.", likes: 5 },
    { name: "Hannah Ivers", description: "In voluptate velit esse cillum dolore.", likes: 20 },
    { name: "Isabella King", description: "Excepteur sint occaecat cupidatat non proident.", likes: 17 },
    { name: "Jack Lee", description: "Sunt in culpa qui officia deserunt mollit anim.", likes: 14 },
    { name: "Katherine Moore", description: "Laboris nisi ut aliquip ex ea commodo.", likes: 19 },
    { name: "Liam Nelson", description: "Duis aute irure dolor in reprehenderit in voluptate.", likes: 11 },
    { name: "Mia O'Connor", description: "Velit esse cillum dolore eu fugiat nulla pariatur.", likes: 23 },
    { name: "Noah Parker", description: "At vero eos et accusamus et iusto odio dignissimos.", likes: 9 },
    { name: "Olivia Quinn", description: "Tempor incididunt ut labore et dolore magna aliqua.", likes: 26 },
    { name: "Paul Roberts", description: "Ut enim ad minim veniam, quis nostrud exercitation.", likes: 8 },
    { name: "Quinn Smith", description: "Excepteur sint occaecat cupidatat non proident.", likes: 29 },
    { name: "Rachel Taylor", description: "Sed ut perspiciatis unde omnis iste natus error.", likes: 16 },
    { name: "John Doe", description: "Test", likes: 12 },
    { name: "Jane Smith", description: "Lorem ipsum dolor sit amet.", likes: 25 },
    { name: "Alice Johnson", description: "Consectetur adipiscing elit.", likes: 30 },
    { name: "Bob Brown", description: "Sed do eiusmod tempor incididunt.", likes: 18 },
    { name: "Charlie Davis", description: "Ut labore et dolore magna aliqua.", likes: 22 },
    { name: "Diana Evans", description: "Ut enim ad minim veniam.", likes: 15 },
    { name: "Ethan Foster", description: "Quis nostrud exercitation ullamco laboris.", likes: 10 },
    { name: "Fiona Green", description: "Nisi ut aliquip ex ea commodo consequat.", likes: 28 },
    { name: "George Harris", description: "Duis aute irure dolor in reprehenderit.", likes: 5 },
    { name: "Hannah Ivers", description: "In voluptate velit esse cillum dolore.", likes: 20 },
    { name: "Isabella King", description: "Excepteur sint occaecat cupidatat non proident.", likes: 17 },
    { name: "Jack Lee", description: "Sunt in culpa qui officia deserunt mollit anim.", likes: 14 },
    { name: "Katherine Moore", description: "Laboris nisi ut aliquip ex ea commodo.", likes: 19 },
    { name: "Liam Nelson", description: "Duis aute irure dolor in reprehenderit in voluptate.", likes: 11 },
    { name: "Mia O'Connor", description: "Velit esse cillum dolore eu fugiat nulla pariatur.", likes: 23 },
    { name: "Noah Parker", description: "At vero eos et accusamus et iusto odio dignissimos.", likes: 9 },
    { name: "Olivia Quinn", description: "Tempor incididunt ut labore et dolore magna aliqua.", likes: 26 },
    { name: "Paul Roberts", description: "Ut enim ad minim veniam, quis nostrud exercitation.", likes: 8 },
    { name: "Quinn Smith", description: "Excepteur sint occaecat cupidatat non proident.", likes: 29 },
    { name: "Rachel Taylor", description: "Sed ut perspiciatis unde omnis iste natus error.", likes: 16 },
    { name: "John Doe", description: "Test", likes: 12 },
    { name: "Jane Smith", description: "Lorem ipsum dolor sit amet.", likes: 25 },
    { name: "Alice Johnson", description: "Consectetur adipiscing elit.", likes: 30 },
    { name: "Bob Brown", description: "Sed do eiusmod tempor incididunt.", likes: 18 },
    { name: "Charlie Davis", description: "Ut labore et dolore magna aliqua.", likes: 22 },
    { name: "Diana Evans", description: "Ut enim ad minim veniam.", likes: 15 },
    { name: "Ethan Foster", description: "Quis nostrud exercitation ullamco laboris.", likes: 10 },
    { name: "Fiona Green", description: "Nisi ut aliquip ex ea commodo consequat.", likes: 28 },
    { name: "George Harris", description: "Duis aute irure dolor in reprehenderit.", likes: 5 },
    { name: "Hannah Ivers", description: "In voluptate velit esse cillum dolore.", likes: 20 },
    { name: "Isabella King", description: "Excepteur sint occaecat cupidatat non proident.", likes: 17 },
    { name: "Jack Lee", description: "Sunt in culpa qui officia deserunt mollit anim.", likes: 14 },
    { name: "Katherine Moore", description: "Laboris nisi ut aliquip ex ea commodo.", likes: 19 },
    { name: "Liam Nelson", description: "Duis aute irure dolor in reprehenderit in voluptate.", likes: 11 },
    { name: "Mia O'Connor", description: "Velit esse cillum dolore eu fugiat nulla pariatur.", likes: 23 },
    { name: "Noah Parker", description: "At vero eos et accusamus et iusto odio dignissimos.", likes: 9 },
    { name: "Olivia Quinn", description: "Tempor incididunt ut labore et dolore magna aliqua.", likes: 26 },
    { name: "Paul Roberts", description: "Ut enim ad minim veniam, quis nostrud exercitation.", likes: 8 },
    { name: "Quinn Smith", description: "Excepteur sint occaecat cupidatat non proident.", likes: 29 },
    { name: "Rachel Taylor", description: "Sed ut perspiciatis unde omnis iste natus error.", likes: 16 },
    { name: "John Doe", description: "Test", likes: 12 },
    { name: "Jane Smith", description: "Lorem ipsum dolor sit amet.", likes: 25 },
    { name: "Alice Johnson", description: "Consectetur adipiscing elit.", likes: 30 },
    { name: "Bob Brown", description: "Sed do eiusmod tempor incididunt.", likes: 18 },
    { name: "Charlie Davis", description: "Ut labore et dolore magna aliqua.", likes: 22 },
    { name: "Diana Evans", description: "Ut enim ad minim veniam.", likes: 15 },
    { name: "Ethan Foster", description: "Quis nostrud exercitation ullamco laboris.", likes: 10 },
    { name: "Fiona Green", description: "Nisi ut aliquip ex ea commodo consequat.", likes: 28 },
    { name: "George Harris", description: "Duis aute irure dolor in reprehenderit.", likes: 5 },
    { name: "Hannah Ivers", description: "In voluptate velit esse cillum dolore.", likes: 20 },
    { name: "Isabella King", description: "Excepteur sint occaecat cupidatat non proident.", likes: 17 },
    { name: "Jack Lee", description: "Sunt in culpa qui officia deserunt mollit anim.", likes: 14 },
    { name: "Katherine Moore", description: "Laboris nisi ut aliquip ex ea commodo.", likes: 19 },
    { name: "Liam Nelson", description: "Duis aute irure dolor in reprehenderit in voluptate.", likes: 11 },
    { name: "Mia O'Connor", description: "Velit esse cillum dolore eu fugiat nulla pariatur.", likes: 23 },
    { name: "Noah Parker", description: "At vero eos et accusamus et iusto odio dignissimos.", likes: 9 },
    { name: "Olivia Quinn", description: "Tempor incididunt ut labore et dolore magna aliqua.", likes: 26 },
    { name: "Paul Roberts", description: "Ut enim ad minim veniam, quis nostrud exercitation.", likes: 8 },
    { name: "Quinn Smith", description: "Excepteur sint occaecat cupidatat non proident.", likes: 29 },
    { name: "Rachel Taylor", description: "Sed ut perspiciatis unde omnis iste natus error.", likes: 16 },
];

function InfiniteScroll() {
    const [visiblePeople, setVisiblePeople] = useState(people.slice(0, 5)); 
    const [position, setPosition] = useState(5); 
    const { ref, inView } = useInView({
        threshold: 0.5, 
    });

    useEffect(() => {
        if (inView && position < people.length) {
        const nextBatch = people.slice(position, position + 5); 
        setVisiblePeople((prev) => [...prev, ...nextBatch]);
        setPosition((prev) => prev + 5); 
        }
    }, [inView, position]);

    return (
        <div className="p-4">
        <div className="flex flex-col gap-[1rem]">
            {visiblePeople.map((person, index) => (
                <Post data={person} position={index}/>
            ))}
        </div>
        {position < people.length && (
            <div ref={ref} className="text-center mt-6">
            <div className="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-gray-500"></div>
            </div>
        )}
        </div>
    );
}

export default InfiniteScroll;
